import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AlbumLoginComponent } from './album-login.component';

describe('AlbumLoginComponent', () => {
  let component: AlbumLoginComponent;
  let fixture: ComponentFixture<AlbumLoginComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AlbumLoginComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AlbumLoginComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
